import { FiltersState } from '@/types/device';
import axios from 'axios';
import { useEffect, useState } from 'react';

export default function useDeviceChartData(filters: FiltersState) {
    const [chartData, setChartData] = useState<any[]>([]);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        const fetchChartData = async () => {
            setLoading(true);
            try {
                const response = await axios.post('/api/charts/device', {
                    device: filters.device,
                    startDate: filters.startDate || '2000-01-01',
                    endDate: filters.endDate || null,
                });
                setChartData(response.data);
            } catch (error) {
                console.error('Failed to fetch chart data:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchChartData();
    }, [filters]);

    return { chartData, loading };
}
