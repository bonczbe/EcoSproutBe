import { LineChart } from '@mui/x-charts/LineChart';
import { useState } from 'react';
import WeatherChartFilters from './WeatherChartFilters';
import MultiSelect from './MultiSelect'; // Import the renamed component

interface FiltersState {
    city: string;
    startDate: string;
    endDate: string;
    timeZone: string;
}

interface FiltersOptions {
    cities: string[];
    startDates: string[];
    endDates: string[];
    timeZones: string[];
}

interface ColourOption {
    label: string;
    value: string;
    color: string;
}

const colourOptions: ColourOption[] = [
    { value: 'chocolate', label: 'Chocolate', color: '#d2691e' },
    { value: 'strawberry', label: 'Strawberry', color: '#ff6347' },
    { value: 'vanilla', label: 'Vanilla', color: '#f3e5ab' },
];

function WeatherChartCard({ filtersOptions }: { filtersOptions: FiltersOptions }) {
    const [filters, setFilters] = useState<FiltersState>({
        city: '',
        startDate: '',
        endDate: '',
        timeZone: '',
    });

    const [selectedValues, setSelectedValues] = useState<ColourOption[]>([]);

    const handleFilterChange = (field: keyof FiltersState, value: string) => {
        setFilters((prev) => ({
            ...prev,
            [field]: value,
        }));
    };

    const handleSelectChange = (selectedOptions: any) => {
        setSelectedValues(selectedOptions);
        console.log(selectedOptions);
    };

    const margin = { right: 24 };
    const uData = [4000, 3000, 2000, 2780, 1890, 2390, 3490];
    const pData = [2400, 1398, 9800, 3908, 4800, 3800, 4300];
    const xLabels = ['Page A', 'Page B', 'Page C', 'Page D', 'Page E', 'Page F', 'Page G'];

    return (
        <div className="flex min-h-48 flex-col items-center justify-center gap-4 rounded-2xl bg-white p-6 shadow-md dark:bg-gray-800">
            <WeatherChartFilters filters={filters} filtersOptions={filtersOptions} onChange={handleFilterChange} />

            {/* Use MultiSelect Component */}
            <MultiSelect
                options={colourOptions}
                value={selectedValues}
                onChange={handleSelectChange}
            />

            <div className="w-9/10 rounded-xl bg-gray-200 p-6 shadow-sm inset-shadow-sm shadow-green-800/20 inset-shadow-green-800/20 dark:bg-gray-900">
                <LineChart
                    height={300}
                    series={[{ data: pData, label: 'pv' }, { data: uData, label: 'uv' }]}
                    xAxis={[{ scaleType: 'point', data: xLabels }]}
                    yAxis={[{ width: 50 }]}
                    margin={margin}
                />
            </div>
        </div>
    );
}

export default WeatherChartCard;
