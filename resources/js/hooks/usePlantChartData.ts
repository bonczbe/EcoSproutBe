import { FiltersState } from '@/types/plant';
import axios from 'axios';
import { useEffect, useState } from 'react';

export default function usePlantChartData(filters: FiltersState) {
    const [chartData, setChartData] = useState<any[]>([]);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        const fetchChartData = async () => {
            setLoading(true);
            try {
                const response = await axios.post('/charts/plant', {
                    plant: filters.plant || 0,
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
