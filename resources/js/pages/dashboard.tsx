import { useEffect, useState } from 'react';
import DashboardLayout from './DashboardLayout';
import tzLookup from 'tz-lookup';

type OverviewProps = {
    user: {
        id: number;
        name: string;
        first_name: string;
        last_name: string;
        email: string;
        email_verified_at: string | null;
        created_at: string;
        updated_at: string;
    };
};

function Overview({ user }: OverviewProps) {
    const formattedDate = new Date(user.created_at).toLocaleDateString();
    const [location, setLocation] = useState<GeolocationCoordinates | null>(null);
    const [time, setTime] = useState<Date | null>(null);
    const [isInfoCardVisible, setIsInfoCardVisible] = useState<boolean>(true);

    const getLocation = () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => setLocation(position.coords),
                (err) => console.error('Error getting location:', err)
            );
        } else {
            console.error('Geolocation is not supported by this browser.');
        }
    };

    const getLocalTimeFromCoords = (lat: number, lon: number) => {
        try {
            const timezone = tzLookup(lat, lon);
            const localTime = new Date().toLocaleString('hu-HU', {
                timeZone: timezone,
                hour12: false
            });
            setTime(new Date(localTime));
        } catch (error) {
            console.error('Error finding timezone:', error);
        }
    };

    useEffect(() => {
        getLocation();
    }, []);

    useEffect(() => {
        if (location) {
            getLocalTimeFromCoords(location.latitude, location.longitude);
        }

        const interval = setInterval(() => {
            if (location) {
                getLocalTimeFromCoords(location.latitude, location.longitude);
            }
        }, 30000);

        return () => clearInterval(interval);
    }, [location]);

    const getGreeting = (): string => {
        if (!time) return 'Welcome back';
        const hour = time.getHours();
        if (hour < 5 || hour > 18) return 'Good evening';
        if (hour >= 5 && hour < 12) return 'Good morning';
        return 'Good afternoon';
    };

    const toggleInfoCardVisibility = () => {
        setIsInfoCardVisible(prevState => !prevState);
    };

    return (
        <div className="space-y-4">
            <div className="text-white rounded-2xl shadow-lg text-center">
                <h1 className="text-4xl font-bold mb-2">
                    {`${getGreeting()}, ${user.first_name}!`}
                </h1>
                {time && (
                    <p className="mt-2 text-white/70 dark:text-white/50">
                        Your local time: <span className="font-semibold">{time.toLocaleString().slice(0, -3)}</span>
                    </p>
                )}
            </div>

            <div className="flex justify-end">
                <button
                    className="text-blue-500 dark:text-blue-400 hover:bg-blue-500 hover:text-white bg-blue-100 dark:bg-blue-950 dark:hover:bg-blue-600 dark:hover:text-white transition duration-300 ease-in-out px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                    onClick={toggleInfoCardVisibility}
                >
                    {isInfoCardVisible ? 'Hide' : 'Show'} User Information
                </button>
            </div>

            <div className='grid grid-cols-1 md:grid-cols-2 gap-6'>
            {/* User Info Card */}
            {isInfoCardVisible && (
                    <div className=" rounded-2xl col-span-full mx-48">
                        <h2 className="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100 text-center">Your Information</h2>
                        <div className='w-full flex flex-row'>
                        <div className="space-y-2 text-gray-700 dark:text-gray-300 m-auto">
                            <p><span className="font-medium">Full Name:</span> {user.first_name} {user.last_name}</p>
                            <p><span className="font-medium">Username:</span> {user.name}</p>
                            <p><span className="font-medium">Email:</span> {user.email}</p>
                        </div>
                        <div className="space-y-2 text-gray-700 dark:text-gray-300 m-auto">
                            <p>
                                <span className="font-medium">Email Verified:</span>
                                {user.email_verified_at ? (
                                    <span className="text-green-600 dark:text-green-400"> Yes</span>
                                ) : (
                                    <span className="text-red-500 dark:text-red-400"> No</span>
                                )}
                            </p>
                            <p><span className="font-medium">Member Since:</span> {formattedDate}</p>
                        </div>
                        </div>
                    </div>

            )}
            {/* Second card */}
            <div className="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md flex items-center justify-center min-h-48">
                <p className="text-gray-500 dark:text-gray-400">More coming soon 🚀</p>
            </div>
            </div>
        </div>
    );
}

Overview.layout = (page: React.ReactNode) => (
    <DashboardLayout title="Overview" breadcrumbs={[{ title: 'Dashboard', href: '/dashboard' }]}>
        {page}
    </DashboardLayout>
);

export default Overview;
