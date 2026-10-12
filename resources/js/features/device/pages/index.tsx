import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { DevicePaginatedData } from "@/types";
import { Head, InfiniteScroll, Link, usePage } from "@inertiajs/react";
import { LockIcon, UnlockIcon } from "lucide-react";
import deviceRoutes from '@/routes/devices';
import AlertSuccess from "@/components/alert-success";
import { useEffect } from "react";

export default function Index({ devices }: { devices: DevicePaginatedData }) {
    const { success } = usePage().flash as {
        success: string
    };



    return (
        <>
            <Head title="Perangkat" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                {success && (<AlertSuccess title={success} />)}

                <Card>
                    <CardHeader>
                        <CardTitle>Daftar Perangkat</CardTitle>
                        <CardDescription>Perangkat yang terhubung</CardDescription>
                    </CardHeader>
                    <CardContent>

                        <InfiniteScroll data="devices" preserveUrl>
                            {devices.data.map((device) => (
                                <Card className="">
                                    <CardContent className="flex gap-4">
                                        <Avatar className="">
                                            <AvatarFallback>
                                                DV
                                            </AvatarFallback>
                                        </Avatar>
                                        <div className=" flex flex-1 w-auto overflow-auto justify-between items-center">
                                            <h3 className="font-bold">{device.name}</h3>
                                            <div className="flex gap-2">
                                                <Button type="button" variant={device.is_locked ? 'default' : 'destructive'} asChild >
                                                    <Link href={deviceRoutes.update(device.id)} method="put" data={{ is_locked: !device.is_locked }}  >
                                                        {
                                                            device.is_locked ? <UnlockIcon size={12} /> : <LockIcon size={12} />
                                                        }
                                                    </Link>
                                                </Button>
                                            </div>
                                        </div>
                                    </CardContent>
                                </Card>
                            ))}
                        </InfiniteScroll>
                    </CardContent>
                </Card>
            </div>
        </>
    )
}