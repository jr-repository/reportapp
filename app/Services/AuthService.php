<?php

namespace App\Services;

use App\Models\AuditLogModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\UserSessionModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Session\Session;

class AuthService
{
    public function __construct(
        private readonly UserModel $userModel = new UserModel(),
        private readonly RoleModel $roleModel = new RoleModel(),
        private readonly UserSessionModel $userSessionModel = new UserSessionModel(),
        private readonly AuditLogModel $auditLogModel = new AuditLogModel(),
        private readonly ?Session $session = null,
    ) {
    }

    public function register(array $data): array
    {
        $validation = service('validation');
        $rules      = config(\Config\Validation::class)->authRegister;

        if (! $validation->setRules($rules)->run($data)) {
            return ['success' => false, 'errors' => $validation->getErrors()];
        }

        $role = $this->roleModel->findByCode('Supervisor');

        if ($role === null) {
            return ['success' => false, 'errors' => ['role' => 'Role Supervisor tidak ditemukan di database.']];
        }

        $userId = $this->userModel->insert([
            'role_id'       => $role['id'],
            'full_name'     => trim((string) $data['fullName']),
            'email'         => strtolower(trim((string) $data['email'])),
            'username'      => trim((string) $data['username']),
            'phone'         => trim((string) ($data['phone'] ?? '')),
            'password_hash' => password_hash((string) $data['password'], PASSWORD_DEFAULT),
            'status'        => 'Active',
        ], true);

        $this->writeAudit((int) $userId, 'Register', 'Users', (int) $userId, ['username' => $data['username']]);

        return ['success' => true, 'userId' => $userId];
    }

    public function attempt(string $login, string $password, RequestInterface $request): bool
    {
        $user = $this->verifyCredentials($login, $password);

        if ($user === null) {
            return false;
        }

        $session = $this->resolveSession();
        $session->regenerate();
        $sessionId = session_id();
        $session->set('authUser', [
            'id'        => (int) $user['id'],
            'full_name' => $user['full_name'],
            'email'     => $user['email'],
            'username'  => $user['username'],
            'role_code' => $user['role_code'],
            'role_name' => $user['role_name'],
            'status'    => $user['status'],
        ]);

        $this->userModel->update($user['id'], ['last_login_at' => date('Y-m-d H:i:s')]);

        if ($sessionId !== '') {
            $this->userSessionModel->where('session_id', $sessionId)->delete();
            $this->userSessionModel->insert([
                'user_id'          => $user['id'],
                'session_id'       => $sessionId,
                'ip_address'       => $request->getIPAddress(),
                'user_agent'       => substr((string) $request->getUserAgent(), 0, 255),
                'last_activity_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $this->writeAudit((int) $user['id'], 'Login', 'Users', (int) $user['id'], ['ip' => $request->getIPAddress()]);

        return true;
    }

    public function verifyCredentials(string $login, string $password): ?array
    {
        $user = $this->userModel->findByLogin(trim($login));

        if ($user === null || $user['status'] !== 'Active') {
            return null;
        }

        if (! password_verify($password, $user['password_hash'])) {
            return null;
        }

        return $user;
    }

    public function currentUser(): ?array
    {
        $user = $this->resolveSession()->get('authUser');

        return is_array($user) ? $user : null;
    }

    public function isLoggedIn(): bool
    {
        return $this->currentUser() !== null;
    }

    public function logout(): void
    {
        $currentUser = $this->currentUser();
        $session     = $this->resolveSession();
        $sessionId   = session_id();

        if ($currentUser !== null) {
            if ($sessionId !== '') {
                $this->userSessionModel->where('session_id', $sessionId)->delete();
            }
            $this->writeAudit((int) $currentUser['id'], 'Logout', 'Users', (int) $currentUser['id']);
        }

        $session->remove('authUser');
        $session->regenerate(true);
    }

    public function writeAudit(?int $userId, string $action, string $entityType, ?int $entityId = null, array $meta = []): void
    {
        $this->auditLogModel->insert([
            'user_id'    => $userId,
            'action'     => $action,
            'entity_type'=> $entityType,
            'entity_id'  => $entityId,
            'meta_json'  => $meta === [] ? null : json_encode($meta, JSON_UNESCAPED_UNICODE),
            'ip_address' => service('request')->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function canManageReport(array $user, array $report): bool
    {
        if (in_array($user['role_code'], ['Admin', 'Manager'], true)) {
            return true;
        }

        return (int) $user['id'] === (int) $report['created_by_user_id'] || (int) $user['id'] === (int) $report['worker_user_id'];
    }

    private function resolveSession(): Session
    {
        return $this->session ?? service('session');
    }
}
