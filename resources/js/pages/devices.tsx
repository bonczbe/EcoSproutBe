import AddDevice from '@/components/devices/AddDevice';
import DeviceList from '@/components/devices/DeviceList';
import DashboardLayout from '../layouts/DashboardLayout';

function Overview() {
    return (
        <>
            <AddDevice />
            <DeviceList />
        </>
    );
}

Overview.layout = (page: React.ReactNode) => (
    <DashboardLayout title="Devices" breadcrumbs={[{ title: 'Devices', href: '/devices' }]}>
        {page}
    </DashboardLayout>
);

export default Overview;
