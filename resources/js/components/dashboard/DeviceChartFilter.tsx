import DropdownSelect from '../ui/DropdownSelect';
import { Input } from '../ui/input';

interface WeatherChartFiltersProps {
    filters: {
        startDate: string;
        endDate: string;
        device?: string;
    };
    filtersOptions: {
        startDate: string | null;
        devices: { id: string; name: string; city: string }[];
    };
    onChange: (field: keyof WeatherChartFiltersProps['filters'], value: string) => void;
}

function DeviceChartFilter({ filters, filtersOptions, onChange }: WeatherChartFiltersProps) {
    const toOptionList = (items: { id: string; name: string; city: string }[]) => [
        { label: 'All', value: -1 },
        ...items.map((item) => ({ label: `${item.city} : ${item.name}`, value: item.id })),
    ];

    return (
        <div className="grid-1 grid justify-center gap-4 lg:grid-cols-2 xl:grid-cols-3">
            <DropdownSelect
                label="Device Name"
                value={filters.device ?? -1}
                options={toOptionList(filtersOptions.devices)}
                onChange={(value: string) => onChange('device', value)}
            />

            <Input
                className={`rounded bg-gray-100 p-2 px-4 dark:bg-gray-700`}
                value={filters.startDate || filtersOptions.startDate || ''}
                onChange={(e) => onChange('startDate', e.target.value)}
                label="Start Date"
                type="datetime-local"
            />
            <Input
                className={`rounded bg-gray-100 p-2 px-4 dark:bg-gray-700`}
                value={filters.endDate || ''}
                onChange={(e) => onChange('endDate', e.target.value)}
                label="End Date"
                type="datetime-local"
            />
        </div>
    );
}

export default DeviceChartFilter;
