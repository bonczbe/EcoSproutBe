import { LineChart } from '@mui/x-charts/LineChart';

type AggregatedWeatherKey = keyof Omit<AggregatedWeather, 'date' | 'count'>;
interface WeatherChartProps {
    data: any[];
    selectedValues: { value: string; label: string }[];
    chartOptions: { value: AggregatedWeatherKey; label: string }[];
}

type AggregatedWeather = {
    date: string;
};

export default function DeviceChart({ data, selectedValues, chartOptions }: WeatherChartProps) {
    const margin = { right: 40 };

    const colorPalette = [
        '#1f77b4', // blue
        '#ff7f0e', // orange
    ];

    const series = chartOptions
        .filter((option) => !selectedValues.some((selected) => selected.value === option.value))
        .map(({ value, label }, index) => ({
            data: data.map((item) => item[value] as number),
            label,
            color: colorPalette[index % colorPalette.length],
        }));

    const xLabels = data.map((item) => new Date(item.updated_at));
    console.log(xLabels);
    return (
        <LineChart
            height={300}
            series={series}
            xAxis={[
                {
                    scaleType: 'time',
                    data: xLabels,
                    tickNumber: 6,
                    valueFormatter: (date) => {
                        const d = new Date(date as Date);
                        return `${d.toLocaleDateString('en-EN')} ${d.toLocaleTimeString('en-EN', {
                            hour: '2-digit',
                            minute: '2-digit',
                        })}`;
                    },
                },
            ]}
            yAxis={[{ width: 50 }]}
            margin={margin}
        />
    );
}
