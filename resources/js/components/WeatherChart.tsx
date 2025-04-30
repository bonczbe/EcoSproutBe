import { LineChart } from '@mui/x-charts/LineChart';

interface WeatherChartProps {
    data: any[];
}

type AggregatedWeather = {
    date: string;
    max_celsius: number;
    min_celsius: number;
    average_celsius: number;
};

export default function WeatherChart({ data }: WeatherChartProps) {
    const margin = { right: 24 };

    const aggregatedByDate = data.reduce<Record<string, AggregatedWeather & { count: number }>>((acc, item) => {
        const date = item.date;
        if (!acc[date]) {
            acc[date] = {
                date,
                max_celsius: parseFloat(item.max_celsius),
                min_celsius: parseFloat(item.min_celsius),
                average_celsius: parseFloat(item.average_celsius),
                count: 1,
            };
        } else {
            acc[date].max_celsius += parseFloat(item.max_celsius);
            acc[date].min_celsius += parseFloat(item.min_celsius);
            acc[date].average_celsius += parseFloat(item.average_celsius);
            acc[date].count += 1;
        }
        return acc;
    }, {});

    const averagedData = Object.values(aggregatedByDate).map((item) => ({
        date: item.date,
        max_celsius: item.max_celsius / item.count,
        min_celsius: item.min_celsius / item.count,
        average_celsius: item.average_celsius / item.count,
    }));

    const xLabels = averagedData.map((item) => item.date);
    const maxCelsius = averagedData.map((item) => item.max_celsius);
    const minCelsius = averagedData.map((item) => item.min_celsius);
    const avgCelsius = averagedData.map((item) => item.average_celsius);

    return (
        <LineChart
            height={300}
            series={[
                { data: maxCelsius, label: 'Max °C' },
                { data: minCelsius, label: 'Min °C' },
                { data: avgCelsius, label: 'Avg °C' },
            ]}
            xAxis={[{ scaleType: 'point', data: xLabels }]}
            yAxis={[{ width: 50 }]}
            margin={margin}
        />
    );
}
