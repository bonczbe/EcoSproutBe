import DashboardLayout from './dashboard';

function Overview() {
    return (
        <div>
            <h1 className="text-2xl font-bold">Welcome</h1>
            <p>This is the dashboard overview.</p>
        </div>
    );
}

Overview.layout = (page: React.ReactNode) => <DashboardLayout title="Overview">{page}</DashboardLayout>;

export default Overview;
