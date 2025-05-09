import useWeatherChartData from '@/hooks/useWeatherChartData';
import { FiltersOptions, FiltersState, weatherOption } from '@/types/weather';
import { useState } from 'react';
import MultiSelect from './MultiSelect';
import WeatherChart from './WeatherChart';
import WeatherChartFilters from './WeatherChartFilters';

export default function WeatherChartCard({ filtersOptions }: { filtersOptions: FiltersOptions }) {
    const [filters, setFilters] = useState<FiltersState>({
        city: '',
        startDate: '',
        endDate: '',
    });

    const [selectedValues, setSelectedValues] = useState<weatherOption[]>([
        { value: 'uv_tomorrow', label: 'UV Index Tomorrow' },
        { value: 'expected_max_celsius', label: 'Expected Max °C Tomorrow' },
        { value: 'expected_min_celsius', label: 'Expected Min °C Tomorrow' },
        { value: 'expected_avgtemp_celsius', label: 'Expected Avg Temp °C Tomorrow' },
    ]);

    const { chartData, loading } = useWeatherChartData(filters);

    const handleFilterChange = (field: keyof FiltersState, value: string) => {
        setFilters((prev) => ({ ...prev, [field]: value }));
    };

    const handleSelectChange = (selectedOptions: weatherOption[]) => {
        setSelectedValues(selectedOptions);
    };

    const chartOptions = [
        { value: 'max_celsius', label: 'Max °C' },
        { value: 'min_celsius', label: 'Min °C' },
        { value: 'average_celsius', label: 'Avg °C' },
        { value: 'uv', label: 'UV Index' },
        { value: 'uv_tomorrow', label: 'UV Index Tomorrow' },
        { value: 'expected_max_celsius', label: 'Expected Max °C Tomorrow' },
        { value: 'expected_min_celsius', label: 'Expected Min °C Tomorrow' },
        { value: 'expected_avgtemp_celsius', label: 'Expected Avg Temp °C Tomorrow' },
    ];

    return (
        <div className="flex min-h-48 flex-col items-center justify-center gap-4 rounded-2xl bg-white p-6 shadow-md dark:bg-gray-800">
            <h1 className="text-2xl font-bold">Weather Chart</h1>

            <WeatherChartFilters filters={filters} filtersOptions={filtersOptions} onChange={handleFilterChange} />

            <MultiSelect options={!loading ? chartOptions : []} value={selectedValues} onChange={handleSelectChange} label="Hide Lines" />

            <div className="w-9/10 rounded-xl bg-gray-400/50 p-6 shadow-sm inset-shadow-sm shadow-green-800/20 inset-shadow-green-800/20">
                <WeatherChart data={chartData} selectedValues={selectedValues} chartOptions={chartOptions} />
            </div>
        </div>
    );
}
