
'use client';

import { UploadCloud, File as FileIcon, X } from 'lucide-react';
import { useMemo, type ChangeEvent } from 'react';
import { Button } from './ui/button';
import { cn } from '@/lib/utils';

type FileUploadProps = {
  value: File | null;
  onChange: (file: File | null) => void;
  label: string;
  className?: string;
  accept?: string;
};

const FileUpload = ({ value, onChange, label, className, accept = "image/*,application/pdf" }: FileUploadProps) => {

  const handleFileChange = (event: ChangeEvent<HTMLInputElement>) => {
    const file = event.target.files?.[0] || null;
    onChange(file);
  };

  const handleRemove = () => {
    onChange(null);
  };

  const filePreview = useMemo(() => {
    if (!value) return null;
    if (value.type.startsWith('image/')) {
        // eslint-disable-next-line @next/next/no-img-element
        return <img src={URL.createObjectURL(value)} alt="Preview" className="h-full w-full object-cover" />;
    }
    return <FileIcon className="h-10 w-10 text-muted-foreground" />;
  }, [value]);

  return (
    <div className={cn('space-y-2', className)}>
      <label className="text-sm font-medium">{label}</label>
      {value ? (
        <div className="relative flex items-center justify-between p-2 border rounded-md h-28">
            <div className="relative h-24 w-24 flex items-center justify-center bg-muted rounded-md overflow-hidden">
                {filePreview}
            </div>
            <div className="flex-1 ml-4 text-sm text-muted-foreground truncate">
                {value.name} ({(value.size / 1024).toFixed(2)} KB)
            </div>
            <Button
                type="button"
                variant="ghost"
                size="icon"
                onClick={handleRemove}
                className="absolute top-2 right-2 h-6 w-6"
            >
                <X className="h-4 w-4" />
            </Button>
        </div>
      ) : (
        <div className="relative flex flex-col items-center justify-center p-6 border-2 border-dashed rounded-md">
          <UploadCloud className="h-10 w-10 text-muted-foreground" />
          <p className="mt-2 text-sm text-muted-foreground">Drag & drop or click to upload</p>
          <input
            type="file"
            accept={accept}
            onChange={handleFileChange}
            className="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
          />
        </div>
      )}
    </div>
  );
};

export default FileUpload;
