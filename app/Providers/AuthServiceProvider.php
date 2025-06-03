use App\Models\User;
use App\Policies\UserPolicy;

public function boot()
{
    $this->registerPolicies();

    Gate::policy(User::class, UserPolicy::class);
}
