import DeviceChartCard from '@/components/dashboard/DeviceChartCard';
import ToggleInfoButton from '@/components/dashboard/ToggleInfoButton';
import UserInfoCard from '@/components/dashboard/UserInfoCard';
import WeatherChartCard from '@/components/dashboard/WeatherChartCard';
import WelcomeCard from '@/components/dashboard/WelcomeCard';
import { PageProps } from '@/types';
import { usePage } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { useEffect, useState } from 'react';
import tzLookup from 'tz-lookup';
import DashboardLayout from '../layouts/DashboardLayout';
import PlantChartCard from '@/components/dashboard/PlantChartCard';

interface OverviewProps {
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
}

interface Filters {
    cities: string[];
    startDate: string | null;
    devices: string[];
    plants: string[];
}

function Overview({ user }: OverviewProps) {
    const [location, setLocation] = useState<GeolocationCoordinates | null>(null);
    const [time, setTime] = useState<Date | null>(null);
    const [isInfoCardVisible, setIsInfoCardVisible] = useState<boolean>(true);
    const { filters } = usePage<PageProps<{ filters: Filters }>>().props;

    const getLocation = () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => setLocation(position.coords),
                (err) => console.error('Error getting location:', err),
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
                hour12: false,
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
        }, 10000);

        return () => clearInterval(interval);
    }, [location]);

    const getGreeting = (): string => {
        if (!time) return 'Welcome back';
        const hour = time.getHours();
        if (hour < 5 || hour > 18) return 'Good evening';
        if (hour >= 5 && hour < 12) return 'Good morning';
        return 'Good afternoon';
    };

    return (
        <div className="space-y-4">
            <WelcomeCard greeting={getGreeting()} firstName={user.first_name} localTime={time?.toLocaleString().slice(0, -3)} />
            <ToggleInfoButton isVisible={isInfoCardVisible} onToggle={() => setIsInfoCardVisible((prev) => !prev)} />
            <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div className="col-span-full">
                    <AnimatePresence mode="wait">
                        {isInfoCardVisible && (
                            <motion.div
                                key="userinfocard"
                                initial={{ opacity: 0, height: 0 }}
                                animate={{ opacity: 1, height: 'auto' }}
                                exit={{ opacity: 0, height: 0 }}
                                transition={{ duration: 0.4, ease: 'easeInOut' }}
                                className="overflow-hidden"
                            >
                                <UserInfoCard user={user} />
                            </motion.div>
                        )}
                    </AnimatePresence>
                </div>

                {
                    /*
                                <WeatherChartCard filtersOptions={filters.weather} />
                                <DeviceChartCard filtersOptions={filters.devices} />
                    */
                }
                <PlantChartCard filtersOptions={filters.plants} />
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
