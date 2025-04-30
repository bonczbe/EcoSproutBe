import useWeatherChartData from '@/hooks/useWeatherChartData';
import { ColourOption, FiltersOptions, FiltersState } from '@/types/weather';
import { useState } from 'react';
import WeatherChart from '../WeatherChart';
import MultiSelect from './MultiSelect';
import WeatherChartFilters from './WeatherChartFilters';

export default function WeatherChartCard({ filtersOptions }: { filtersOptions: FiltersOptions }) {
    const [filters, setFilters] = useState<FiltersState>({
        city: '',
        startDate: '',
        endDate: '',
    });

    const [selectedValues, setSelectedValues] = useState<ColourOption[]>([]);

    const { chartData, loading } = useWeatherChartData(filters);

    const handleFilterChange = (field: keyof FiltersState, value: string) => {
        setFilters((prev) => ({ ...prev, [field]: value }));
    };

    const handleSelectChange = (selectedOptions: ColourOption[]) => {
        setSelectedValues(selectedOptions);
    };

    return (
        <div className="flex min-h-48 flex-col items-center justify-center gap-4 rounded-2xl bg-white p-6 shadow-md dark:bg-gray-800">
            <h1 className="text-2xl font-bold">Weather Chart</h1>

            <WeatherChartFilters filters={filters} filtersOptions={filtersOptions} onChange={handleFilterChange} />

            <MultiSelect
                options={[
                    { value: 'chocolate', label: 'Chocolate' },
                    { value: 'strawberry', label: 'Strawberry' },
                    { value: 'vanilla', label: 'Vanilla' },
                ]}
                value={selectedValues}
                onChange={handleSelectChange}
                label="Hide Lines"
            />

            <div className="w-9/10 rounded-xl bg-gray-400/50 p-6 shadow-sm inset-shadow-sm shadow-green-800/20 inset-shadow-green-800/20">
                {loading ? <div>Loading...</div> : <WeatherChart data={chartData} />}
            </div>
        </div>
    );
}
