import AddDevice from '@/components/devices/AddDevice';
import DeviceList from '@/components/devices/DeviceList';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import DashboardLayout from '../layouts/DashboardLayout';

function Overview({ bdevices, weathers }: any) {
    const [refreshTrigger, setRefreshTrigger] = useState(0);

    const reloadPage = () => {
        router.reload({ only: ['bdevices'] });
        setRefreshTrigger((prev) => prev + 1);
    };

    return (
        <>
            <AddDevice onDeviceAdded={reloadPage} />
            <DeviceList key={refreshTrigger} devices={bdevices} weathers={weathers} reloadPage={reloadPage} />
        </>
    );
}

Overview.layout = (page: React.ReactNode) => (
    <DashboardLayout title="Devices" breadcrumbs={[{ title: 'Devices', href: '/devices' }]}>
        {page}
    </DashboardLayout>
);

export default Overview;
