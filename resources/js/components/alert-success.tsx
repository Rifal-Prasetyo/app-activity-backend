import { AlertCircleIcon } from 'lucide-react';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';

export default function AlertSuccess({
    title,
}: {
    title?: string;
}) {
    return (
        <Alert variant={'default'} className='border-green-200 text-green-400 dark:border-green-400 dark:text-green-500'>
            <AlertCircleIcon />
            <AlertTitle>{title || 'Berhasil'}</AlertTitle>
        </Alert>
    );
}
