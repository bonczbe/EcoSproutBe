import usePlantChartData from '@/hooks/usePlantChartData';
import { FiltersState } from '@/types/plant';
import { FiltersOptions } from '@/types/weather';
import { useState } from 'react';
import PlantChart from './PlantChart';
import PlantChartFilter from './PlantChartFilter';

export default function PlantChartCard({ filtersOptions }: { filtersOptions: FiltersOptions }) {
    const [filters, setFilters] = useState<FiltersState>({
        plant: filtersOptions?.plants[0]?.customer_plant_id ?? 0,
        startDate: filtersOptions.startDate?.split(' ')[0] ?? null,
        endDate: new Date().toISOString().split('T')[0],
    });

    const { chartData, loading } = usePlantChartData(filters);

    const handleFilterChange = (field: keyof FiltersState, value: string) => {
        setFilters((prev) => ({ ...prev, [field]: value }));
    };

    return (
        <div className="flex min-h-48 flex-col items-center justify-center gap-4 rounded-2xl bg-white p-6 shadow-md dark:bg-gray-800">
            <h1 className="text-2xl font-bold">Plant Chart</h1>
            <PlantChartFilter filters={filters} filtersOptions={filtersOptions} onChange={handleFilterChange} />
            <div className="w-9/10 rounded-xl bg-gray-400/50 p-6 shadow-sm inset-shadow-sm shadow-green-800/20 inset-shadow-green-800/20">
                <PlantChart data={chartData} />
            </div>
        </div>
    );
}
