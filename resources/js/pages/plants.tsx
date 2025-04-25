import DashboardLayout from './DashboardLayout';

function Overview() {
    return (
        <div>
            <h1 className="text-2xl font-bold">Welcome</h1>
            <p>This is the dashboard overview.</p>
        </div>
    );
}

Overview.layout = (page: React.ReactNode) => (
    <DashboardLayout title="Plants" breadcrumbs={[{ title: 'Plants', href: '/plants' }]}>
        {page}
    </DashboardLayout>
);

export default Overview;
