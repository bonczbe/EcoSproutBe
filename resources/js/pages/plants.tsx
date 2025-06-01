import AddPlant from '@/components/plants/AddPlant';
import PlantList from '@/components/plants/PlantList';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import DashboardLayout from '../layouts/DashboardLayout';

function Overview({ plants, devices, plantFamilies }: any) {
    const [refreshTrigger, setRefreshTrigger] = useState(0);
    const reloadPage = () => {
        router.reload({ only: ['plants'] });
        setRefreshTrigger((prev) => prev + 1);
    };
    return (
        <div>
            <AddPlant onPlantAdded={reloadPage} devices={devices} plantFamilies={plantFamilies} />
            <PlantList plants={plants} />
        </div>
    );
}

Overview.layout = (page: React.ReactNode) => (
    <DashboardLayout title="Plants" breadcrumbs={[{ title: 'Plants', href: '/plants' }]}>
        {page}
    </DashboardLayout>
);

export default Overview;
