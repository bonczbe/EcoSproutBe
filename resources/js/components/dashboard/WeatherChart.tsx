import { LineChart } from '@mui/x-charts/LineChart';

type AggregatedWeatherKey = keyof Omit<AggregatedWeather, 'date' | 'count'>;
interface WeatherChartProps {
    data: any[];
    selectedValues: { value: string; label: string }[];
    chartOptions: { value: AggregatedWeatherKey; label: string }[];
}

type AggregatedWeather = {
    date: string;
    max_celsius: number;
    min_celsius: number;
    average_celsius: number;
    totalprecip_mm: number;
    uv: number;
    uv_tomorrow: number;
    rain_chance: number;
    snow_chance: number;
    rain_chance_tomorrow: number;
    snow_chance_tomorrow: number;
    expected_maximum_rain: number;
    expected_maximum_snow: number;
    expected_maximum_rain_tomorrow: number;
    expected_maximum_snow_tomorrow: number;
    expected_max_celsius: number;
    expected_min_celsius: number;
    expected_avgtemp_celsius: number;
    count: number;
};

function safeParseFloat(value: any): number {
    const parsed = parseFloat(value);
    return isNaN(parsed) ? 0 : parsed;
}

export default function WeatherChart({ data, selectedValues, chartOptions }: WeatherChartProps) {
    const margin = { right: 40 };

    const aggregatedByDate = data.reduce<Record<string, AggregatedWeather>>((acc, item) => {
        const date = item.date;

        if (!acc[date]) {
            acc[date] = {
                date,
                max_celsius: safeParseFloat(item.max_celsius),
                min_celsius: safeParseFloat(item.min_celsius),
                average_celsius: safeParseFloat(item.average_celsius),
                totalprecip_mm: safeParseFloat(item.totalprecip_mm),
                uv: safeParseFloat(item.uv),
                uv_tomorrow: safeParseFloat(item.uv_tomorrow),
                rain_chance: safeParseFloat(item.rain_chance),
                snow_chance: safeParseFloat(item.snow_chance),
                rain_chance_tomorrow: safeParseFloat(item.rain_chance_tomorrow),
                snow_chance_tomorrow: safeParseFloat(item.snow_chance_tomorrow),
                expected_maximum_rain: safeParseFloat(item.expected_maximum_rain),
                expected_maximum_snow: safeParseFloat(item.expected_maximum_snow),
                expected_maximum_rain_tomorrow: safeParseFloat(item.expected_maximum_rain_tomorrow),
                expected_maximum_snow_tomorrow: safeParseFloat(item.expected_maximum_snow_tomorrow),
                expected_max_celsius: safeParseFloat(item.expected_max_celsius),
                expected_min_celsius: safeParseFloat(item.expected_min_celsius),
                expected_avgtemp_celsius: safeParseFloat(item.expected_avgtemp_celsius),
                count: 1,
            };
        } else {
            acc[date].max_celsius += safeParseFloat(item.max_celsius);
            acc[date].min_celsius += safeParseFloat(item.min_celsius);
            acc[date].average_celsius += safeParseFloat(item.average_celsius);
            acc[date].totalprecip_mm += safeParseFloat(item.totalprecip_mm);
            acc[date].uv += safeParseFloat(item.uv);
            acc[date].uv_tomorrow += safeParseFloat(item.uv_tomorrow);
            acc[date].rain_chance += safeParseFloat(item.rain_chance);
            acc[date].snow_chance += safeParseFloat(item.snow_chance);
            acc[date].rain_chance_tomorrow += safeParseFloat(item.rain_chance_tomorrow);
            acc[date].snow_chance_tomorrow += safeParseFloat(item.snow_chance_tomorrow);
            acc[date].expected_maximum_rain += safeParseFloat(item.expected_maximum_rain);
            acc[date].expected_maximum_snow += safeParseFloat(item.expected_maximum_snow);
            acc[date].expected_maximum_rain_tomorrow += safeParseFloat(item.expected_maximum_rain_tomorrow);
            acc[date].expected_maximum_snow_tomorrow += safeParseFloat(item.expected_maximum_snow_tomorrow);
            acc[date].expected_max_celsius += safeParseFloat(item.expected_max_celsius);
            acc[date].expected_min_celsius += safeParseFloat(item.expected_min_celsius);
            acc[date].expected_avgtemp_celsius += safeParseFloat(item.expected_avgtemp_celsius);
            acc[date].count += 1;
        }

        return acc;
    }, {});

    const averagedData = Object.values(aggregatedByDate).map((item) => ({
        date: item.date,
        max_celsius: item.max_celsius / item.count,
        min_celsius: item.min_celsius / item.count,
        average_celsius: item.average_celsius / item.count,
        totalprecip_mm: item.totalprecip_mm / item.count,
        uv: item.uv / item.count,
        uv_tomorrow: item.uv_tomorrow / item.count,
        rain_chance: item.rain_chance / item.count,
        snow_chance: item.snow_chance / item.count,
        rain_chance_tomorrow: item.rain_chance_tomorrow / item.count,
        snow_chance_tomorrow: item.snow_chance_tomorrow / item.count,
        expected_maximum_rain: item.expected_maximum_rain / item.count,
        expected_maximum_snow: item.expected_maximum_snow / item.count,
        expected_maximum_rain_tomorrow: item.expected_maximum_rain_tomorrow / item.count,
        expected_maximum_snow_tomorrow: item.expected_maximum_snow_tomorrow / item.count,
        expected_max_celsius: item.expected_max_celsius / item.count,
        expected_min_celsius: item.expected_min_celsius / item.count,
        expected_avgtemp_celsius: item.expected_avgtemp_celsius / item.count,
    }));

    const xLabels = averagedData.map((item) => item.date);

    const colorPalette = [
        '#1f77b4', // blue
        '#ff7f0e', // orange
        '#2ca02c', // green
        '#d62728', // red
        '#9467bd', // purple
        '#8c564b', // brown
        '#e377c2', // pink
        '#7f7f7f', // gray
        '#bcbd22', // olive
        '#17becf', // cyan
    ];

    const series = chartOptions
        .filter((option) => !selectedValues.some((selected) => selected.value === option.value))
        .map(({ value, label }, index) => ({
            data: averagedData.map((item) => item[value] as number),
            label,
            color: colorPalette[index % colorPalette.length],
        }));

    return <LineChart height={300} series={series} xAxis={[{ scaleType: 'point', data: xLabels }]} yAxis={[{ width: 50 }]} margin={margin} />;
}
