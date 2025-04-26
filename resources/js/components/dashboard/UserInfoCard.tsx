type UserInfoCardProps = {
    user: {
        first_name: string;
        last_name: string;
        name: string;
        email: string;
        email_verified_at: string | null;
        created_at: string;
    };
};

function UserInfoCard({ user }: UserInfoCardProps) {
    const formattedDate = new Date(user.created_at).toLocaleDateString();

    return (
        <div className="col-span-full mx-48 rounded-2xl">
            <h2 className="mb-4 text-center text-2xl font-semibold text-gray-800 dark:text-gray-100">Your Information</h2>
            <div className="flex w-full flex-row">
                <div className="m-auto space-y-2 text-gray-700 dark:text-gray-300">
                    <p>
                        <span className="font-medium">Full Name:</span> {user.first_name} {user.last_name}
                    </p>
                    <p>
                        <span className="font-medium">Username:</span> {user.name}
                    </p>
                    <p>
                        <span className="font-medium">Email:</span> {user.email}
                    </p>
                </div>
                <div className="m-auto space-y-2 text-gray-700 dark:text-gray-300">
                    <p>
                        <span className="font-medium">Email Verified:</span>
                        {user.email_verified_at ? (
                            <span className="text-green-600 dark:text-green-400"> Yes</span>
                        ) : (
                            <span className="text-red-500 dark:text-red-400"> No</span>
                        )}
                    </p>
                    <p>
                        <span className="font-medium">Member Since:</span> {formattedDate}
                    </p>
                </div>
            </div>
        </div>
    );
}

export default UserInfoCard;
