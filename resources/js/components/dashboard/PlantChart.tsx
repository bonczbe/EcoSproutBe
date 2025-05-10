import { LineChart } from '@mui/x-charts/LineChart';

interface PlantChartProp {
    data: any[];
}

export default function PlantChart({ data }: PlantChartProp) {
    const margin = { right: 40 };

    const xLabels = data.map((item) => new Date(item.updated_at));
    const moistureLevels = data.map((item) => item.moisture_level);

    const series = [
        {
            data: moistureLevels,
            label: 'Moisture Level',
            color: '#1f77b4',
        },
    ];

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
