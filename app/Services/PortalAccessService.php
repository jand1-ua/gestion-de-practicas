<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Tutor;
use App\Models\User;
use DomainException;

class PortalAccessService
{
    public function createAlumnoAccess(Alumno $alumno): array
    {
        $user = $this->resolveAlumnoUser($alumno);
        $temporaryPassword = $this->generateTemporaryPassword();

        $this->guardEmailAvailability($alumno->email, $user);

        $user ??= new User();
        $user->fill([
            'name' => $alumno->nombre,
            'email' => $alumno->email,
            'password' => $temporaryPassword,
            'role' => User::ROLE_ALUMNO,
            'alumno_id' => $alumno->id,
            'tutor_id' => null,
            'must_change_password' => true,
        ]);
        $user->save();

        return $this->credentialsPayload($user, $temporaryPassword, 'Alumno');
    }

    public function createTutorAccess(Tutor $tutor): array
    {
        $user = $this->resolveTutorUser($tutor);
        $temporaryPassword = $this->generateTemporaryPassword();

        $this->guardEmailAvailability($tutor->email, $user);

        $user ??= new User();
        $user->fill([
            'name' => $tutor->nombre,
            'email' => $tutor->email,
            'password' => $temporaryPassword,
            'role' => User::ROLE_TUTOR,
            'alumno_id' => null,
            'tutor_id' => $tutor->id,
            'must_change_password' => true,
        ]);
        $user->save();

        return $this->credentialsPayload($user, $temporaryPassword, 'Tutor');
    }

    public function createCoordinatorAccess(string $name, string $email): array
    {
        $this->guardEmailAvailability($email);
        $temporaryPassword = $this->generateTemporaryPassword();

        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => $temporaryPassword,
            'role' => User::ROLE_COORDINADOR,
            'alumno_id' => null,
            'tutor_id' => null,
            'must_change_password' => true,
        ]);

        return $this->credentialsPayload($user, $temporaryPassword, 'Coordinador');
    }

    public function updateCoordinatorAccess(User $user, string $name, string $email): void
    {
        $this->guardCoordinatorUser($user);
        $this->guardEmailAvailability($email, $user);

        $user->fill([
            'name' => $name,
            'email' => $email,
            'role' => User::ROLE_COORDINADOR,
            'alumno_id' => null,
            'tutor_id' => null,
        ]);
        $user->save();
    }

    public function resetCoordinatorPassword(User $user): array
    {
        $this->guardCoordinatorUser($user);
        $temporaryPassword = $this->generateTemporaryPassword();

        $user->fill([
            'password' => $temporaryPassword,
            'must_change_password' => true,
        ]);
        $user->save();

        return $this->credentialsPayload($user, $temporaryPassword, 'Coordinador');
    }

    public function syncAlumnoAccess(Alumno $alumno): void
    {
        $user = $this->resolveAlumnoUser($alumno);

        if (! $user) {
            return;
        }

        $this->guardEmailAvailability($alumno->email, $user);

        $user->fill([
            'name' => $alumno->nombre,
            'email' => $alumno->email,
            'role' => User::ROLE_ALUMNO,
            'alumno_id' => $alumno->id,
            'tutor_id' => null,
        ]);
        $user->save();
    }

    public function syncTutorAccess(Tutor $tutor): void
    {
        $user = $this->resolveTutorUser($tutor);

        if (! $user) {
            return;
        }

        $this->guardEmailAvailability($tutor->email, $user);

        $user->fill([
            'name' => $tutor->nombre,
            'email' => $tutor->email,
            'role' => User::ROLE_TUTOR,
            'alumno_id' => null,
            'tutor_id' => $tutor->id,
        ]);
        $user->save();
    }

    public function deleteAlumnoAccess(Alumno $alumno): void
    {
        $user = $this->resolveAlumnoUser($alumno);

        if ($user) {
            $user->delete();
        }
    }

    public function deleteTutorAccess(Tutor $tutor): void
    {
        $user = $this->resolveTutorUser($tutor);

        if ($user) {
            $user->delete();
        }
    }

    private function resolveAlumnoUser(Alumno $alumno): ?User
    {
        return User::query()
            ->where('role', User::ROLE_ALUMNO)
            ->where('alumno_id', $alumno->id)
            ->first();
    }

    private function resolveTutorUser(Tutor $tutor): ?User
    {
        return User::query()
            ->where('role', User::ROLE_TUTOR)
            ->where('tutor_id', $tutor->id)
            ->first();
    }

    private function guardCoordinatorUser(User $user): void
    {
        if (! $user->isCoordinator()) {
            throw new DomainException('La cuenta indicada no corresponde a un coordinador.');
        }
    }

    private function guardEmailAvailability(string $email, ?User $currentUser = null): void
    {
        $conflict = User::query()
            ->where('email', $email)
            ->when($currentUser, fn ($query) => $query->whereKeyNot($currentUser->id))
            ->first();

        if ($conflict) {
            throw new DomainException('Ya existe otra cuenta de acceso con ese email. Actualiza el email o revisa los usuarios existentes antes de generar el acceso.');
        }
    }

    private function credentialsPayload(User $user, string $temporaryPassword, string $roleLabel): array
    {
        return [
            'email' => $user->email,
            'password' => $temporaryPassword,
            'role_label' => $roleLabel,
            'name' => $user->name,
        ];
    }

    private function generateTemporaryPassword(int $length = 12): string
    {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
        $password = '';
        $maxIndex = strlen($alphabet) - 1;

        for ($i = 0; $i < $length; $i++) {
            $password .= $alphabet[random_int(0, $maxIndex)];
        }

        return $password;
    }
}
