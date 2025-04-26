import DropdownSelect from '../ui/DropdownSelect';

interface WeatherChartFiltersProps {
    filters: {
        city: string;
        startDate: string;
        endDate: string;
        timeZone: string;
    };
    filtersOptions: {
        cities: string[];
        startDates: string[];
        endDates: string[];
        timeZones: string[];
    };
    onChange: (field: keyof WeatherChartFiltersProps['filters'], value: string) => void;
}

function WeatherChartFilters({ filters, filtersOptions, onChange }: WeatherChartFiltersProps) {
    const toOptionList = (items: string[]) => items.map((item) => ({ label: item, value: item }));

    return (
        <div className="grid-1 grid justify-center gap-4 lg:grid-cols-2 xl:grid-cols-4">
            <DropdownSelect
                label="City"
                value={filters.city}
                options={toOptionList(filtersOptions.cities)}
                onChange={(value) => onChange('city', value)}
            />
            <DropdownSelect
                label="Time Zone"
                value={filters.timeZone}
                options={toOptionList(filtersOptions.timeZones)}
                onChange={(value) => onChange('timeZone', value)}
            />
            <DropdownSelect
                label="Start Date"
                value={filters.startDate}
                options={toOptionList(filtersOptions.startDates)}
                onChange={(value) => onChange('startDate', value)}
            />
            <DropdownSelect
                label="End Date"
                value={filters.endDate}
                options={toOptionList(filtersOptions.endDates)}
                onChange={(value) => onChange('endDate', value)}
            />
        </div>
    );
}

export default WeatherChartFilters;
