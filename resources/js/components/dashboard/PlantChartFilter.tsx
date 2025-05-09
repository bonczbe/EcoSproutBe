import DropdownSelect from '../ui/DropdownSelect';
import { Input } from '../ui/input';

interface WeatherChartFiltersProps {
    filters: {
        city: string;
        startDate: string;
        endDate: string;
    };
    filtersOptions: {
        cities: string[];
        startDate: string | null;
    };
    onChange: (field: keyof WeatherChartFiltersProps['filters'], value: string) => void;
}

function PlantChartFilter({ filters, filtersOptions, onChange }: WeatherChartFiltersProps) {
    const toOptionList = (items: string[]) =>
        items.map((item) => ({ label: +item.customer_plant_id + ' : ' + item.plant_name_botanical, value: item.customer_plant_id }));
    return (
        <div className="grid-1 grid justify-center gap-4 lg:grid-cols-2 xl:grid-cols-3">
            {
                <DropdownSelect
                    className="col-span-full"
                    label="Plant"
                    value={filters.plant}
                    options={toOptionList(filtersOptions.plants)}
                    onChange={(value) => onChange('plant', value)}
                />
            }

            <Input
                className={`rounded bg-gray-100 p-2 px-4 dark:bg-gray-700`}
                value={filters.startDate || filtersOptions.startDate || ''}
                onChange={(value) => onChange('startDate', value.target.value)}
                label="Start Date"
                type="date"
            />
            <Input
                className={`rounded bg-gray-100 p-2 px-4 dark:bg-gray-700`}
                label="End Date"
                type="date"
                value={filters.endDate}
                onChange={(value) => onChange('endDate', value.target.value)}
            />
        </div>
    );
}

export default PlantChartFilter;
