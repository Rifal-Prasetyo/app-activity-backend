export type Device = {
    id: number;
    name: string;
    device_uuid: string;
    is_locked: boolean;
    created_at: string;
    updated_at: string;
}

export interface DevicePaginatedData {
    data: Device[];
}