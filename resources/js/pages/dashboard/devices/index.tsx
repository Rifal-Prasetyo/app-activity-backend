import IndexPage from '@/features/device/pages/index';
import { DevicePaginatedData } from '@/types';
import { usePage } from '@inertiajs/react';

export default function Index() {
    const { devices } = usePage<{
        devices: DevicePaginatedData
    }>().props
    return <IndexPage devices={devices} />
}