import { FiltersOptions, FiltersState, weatherOption } from '@/types/weather';
import { useState } from 'react';
import DeviceChartFilter from './DeviceChartFilter';
import MultiSelect from './MultiSelect';

export default function DeviceChartCard({ filtersOptions }: { filtersOptions: FiltersOptions }) {
    const [filters, setFilters] = useState<FiltersState>({
        city: '',
        startDate: '',
        endDate: '',
    });

    const [selectedValues, setSelectedValues] = useState<weatherOption[]>([]);

    const handleFilterChange = (field: keyof FiltersState, value: string) => {
        setFilters((prev) => ({ ...prev, [field]: value }));
    };

    const handleSelectChange = (selectedOptions: weatherOption[]) => {
        setSelectedValues(selectedOptions);
    };

    const chartOptions = [
        { value: 'water_level', label: 'Water level' },
        { value: 'temperature', label: 'Temperature °C' },
    ];

    return (
        <div className="flex min-h-48 flex-col items-center justify-center gap-4 rounded-2xl bg-white p-6 shadow-md dark:bg-gray-800">
            <h1 className="text-2xl font-bold">Device Chart</h1>

            <DeviceChartFilter filters={filters} filtersOptions={filtersOptions} onChange={handleFilterChange} />

            <MultiSelect options={!false ? chartOptions : []} value={selectedValues} onChange={handleSelectChange} label="Hide Lines" />
            {/*
            <div className="w-9/10 rounded-xl bg-gray-400/50 p-6 shadow-sm inset-shadow-sm shadow-green-800/20 inset-shadow-green-800/20">
                <WeatherChart data={chartData} selectedValues={selectedValues} chartOptions={chartOptions} />
            </div>

*/}
        </div>
    );
}
