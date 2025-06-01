import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { ReactNode } from 'react';
import { Toaster } from 'react-hot-toast';

type Props = {
    children: ReactNode;
    title?: string;
    breadcrumbs: BreadcrumbItem[];
};

export default function DashboardLayout({ children, title = 'Dashboard', breadcrumbs }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={title} />
            <Toaster position="top-right" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">{children}</div>
        </AppLayout>
    );
}
