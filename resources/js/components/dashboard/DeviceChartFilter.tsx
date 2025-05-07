import DropdownSelect from '../ui/DropdownSelect';
import { Input } from '../ui/input';

interface WeatherChartFiltersProps {
    filters: {
        startDate: string;
        endDate: string;
    };
    filtersOptions: {
        startDate: string | null;
        devices: { id: string; name: string; device: string }[];
    };
    onChange: (field: keyof WeatherChartFiltersProps['filters'], value: string) => void;
}

function DeviceChartFilter({ filters, filtersOptions, onChange }: WeatherChartFiltersProps) {
    console.log(filtersOptions);
    const toOptionList = (items: string[]) => [
        { label: 'All', value: 'all' },
        ...items.map((item) => ({ label: item.device + ' : ' + item.name, value: item.id })),
    ];
    return (
        <div className="grid-1 grid justify-center gap-4 lg:grid-cols-2 xl:grid-cols-3">
            <DropdownSelect
                label="Device Name"
                value={filters.device ?? -1}
                options={toOptionList(filtersOptions.devices)}
                onChange={(value) => onChange('device', value)}
            />

            <Input
                className={`rounded bg-gray-100 p-2 px-4 dark:bg-gray-700`}
                value={filters.startDate || filtersOptions.startDate || ''}
                onChange={(value) => onChange('startDate', value.target.value)}
                label="Start Date"
                type="datetime-local"
            />
            <Input
                className={`rounded bg-gray-100 p-2 px-4 dark:bg-gray-700`}
                value={filters.endDate}
                onChange={(value) => onChange('endDate', value.target.value)}
                label="End Date"
                type="datetime-local"
            />
        </div>
    );
}

export default DeviceChartFilter;
