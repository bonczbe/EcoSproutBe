import AddDevice from '@/components/devices/AddDevice';
import DeviceList from '@/components/devices/DeviceList';
import { useState } from 'react';
import DashboardLayout from '../layouts/DashboardLayout';

function Overview() {
    const [refreshTrigger, setRefreshTrigger] = useState(0);

    const handleDeviceAdded = () => {
        setRefreshTrigger((prev) => prev + 1);
    };

    return (
        <>
            <AddDevice onDeviceAdded={handleDeviceAdded} />
            <DeviceList key={refreshTrigger} />
        </>
    );
}

Overview.layout = (page: React.ReactNode) => (
    <DashboardLayout title="Devices" breadcrumbs={[{ title: 'Devices', href: '/devices' }]}>
        {page}
    </DashboardLayout>
);

export default Overview;
