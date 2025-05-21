import Device from './Device';

export default function DeviceList({ devices, weathers, reloadPage }: { devices: any[]; weathers: any[]; reloadPage: () => void }) {
    const handleUpdate = (deviceId: number) => {
        console.log('Update device:', deviceId);
        reloadPage();
    };

    const handleDelete = (deviceId: number) => {
        console.log('Delete device:', deviceId);
        reloadPage();
    };

    const findWeatherForCity = (city: string) => {
        return weathers.find((w) => w.city.toLowerCase() === city.toLowerCase());
    };

    return (
        <div className="grid gap-4">
            {devices.map((device) => (
                <Device
                    key={device.id}
                    device={device}
                    weather={findWeatherForCity(device.city)}
                    handleDelete={handleDelete}
                    handleUpdate={handleUpdate}
                />
            ))}
        </div>
    );
}
