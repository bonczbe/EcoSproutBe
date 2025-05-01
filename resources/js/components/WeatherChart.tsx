import { LineChart } from '@mui/x-charts/LineChart';

interface WeatherChartProps {
    data: any[];
    selectedValues: { value: string; label: string }[];
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
    condition: any[];
    astro: any[];
};

function safeParseFloat(value: any): number {
    const parsed = parseFloat(value);
    return isNaN(parsed) ? 0 : parsed;
}

export default function WeatherChart({ data, selectedValues }: WeatherChartProps) {
    const margin = { right: 24 };

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
                condition: [item.condition],
                astro: [item.astro],
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
        condition: item.condition,
        astro: item.astro,
    }));

    const xLabels = averagedData.map((item) => item.date);
    const maxCelsius = averagedData.map((item) => item.max_celsius);
    const minCelsius = averagedData.map((item) => item.min_celsius);
    const avgCelsius = averagedData.map((item) => item.average_celsius);
    const uvData = averagedData.map((item) => item.uv);
    const uvTomorrow = averagedData.map((item) => item.uv_tomorrow);
    const maxCelsiusExpected = averagedData.map((item) => item.expected_max_celsius);
    const minCelsiusExpected = averagedData.map((item) => item.expected_min_celsius);
    const avgTempCelsiusExpected = averagedData.map((item) => item.expected_avgtemp_celsius);

    console.log(selectedValues);

    const series = [
        { data: maxCelsius, label: 'Max °C' },
        { data: minCelsius, label: 'Min °C' },
        { data: avgCelsius, label: 'Avg °C' },
        { data: uvData, label: 'UV Index' },
        { data: uvTomorrow, label: 'UV Index Tomorrow' },
        { data: maxCelsiusExpected, label: 'Expected Max °C Tomorrow' },
        { data: minCelsiusExpected, label: 'Expected Min °C Tomorrow' },
        { data: avgTempCelsiusExpected, label: 'Expected Avg Temp °C Tomorrow' },
    ];

    return (
        <LineChart
            height={300}
            series={[
                { data: maxCelsius, label: 'Max °C' },
                { data: minCelsius, label: 'Min °C' },
                { data: avgCelsius, label: 'Avg °C' },
                { data: uvData, label: 'UV Index' },
                { data: uvTomorrow, label: 'UV Index Tomorrow' },
                { data: maxCelsiusExpected, label: 'Expected Max °C Tomorrow' },
                { data: minCelsiusExpected, label: 'Expected Min °C Tomorrow' },
                { data: avgTempCelsiusExpected, label: 'Expected Avg Temp °C Tomorrow' },
            ]}
            xAxis={[{ scaleType: 'point', data: xLabels }]}
            yAxis={[{ width: 50 }]}
            margin={margin}
        />
    );
}
