import AddDevice from '@/components/devices/AddDevice';
import DeviceList from '@/components/devices/DeviceList';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import DashboardLayout from '../layouts/DashboardLayout';

function Overview({ bdevices }: any) {
    const [refreshTrigger, setRefreshTrigger] = useState(0);

    const handleDeviceAdded = () => {
        router.reload({ only: ['bdevices'] });
        setRefreshTrigger((prev) => prev + 1);
    };

    return (
        <>
            <AddDevice onDeviceAdded={handleDeviceAdded} />
            <DeviceList key={refreshTrigger} devices={bdevices} />
        </>
    );
}

Overview.layout = (page: React.ReactNode) => (
    <DashboardLayout title="Devices" breadcrumbs={[{ title: 'Devices', href: '/devices' }]}>
        {page}
    </DashboardLayout>
);

export default Overview;
