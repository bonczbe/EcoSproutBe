type WelcomeCardProps = {
    greeting: string;
    firstName: string;
    localTime?: string;
};

function WelcomeCard({ greeting, firstName, localTime }: WelcomeCardProps) {
    return (
        <div className="rounded-2xl text-center text-white shadow-lg">
            <h1 className="mb-2 text-4xl font-bold">{`${greeting}, ${firstName}!`}</h1>
            {localTime && (
                <p className="mt-2 text-white/70 dark:text-white/50">
                    Your local time: <span className="font-semibold">{localTime}</span>
                </p>
            )}
        </div>
    );
}

export default WelcomeCard;
