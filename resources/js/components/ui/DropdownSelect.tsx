import React from 'react';

interface DropdownSelectProps {
    label?: string;
    value: string;
    options: { label: string; value: string }[];
    onChange: (value: string) => void;
    className?: string;
}

function DropdownSelect({ label, value, options, onChange, className }: DropdownSelectProps) {
    const handleChange = (event: React.ChangeEvent<HTMLSelectElement>) => {
        onChange(event.target.value);
    };

    return (
        <div className="flex flex-col">
            {label && <label className="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">{label}</label>}
            <select
                value={value}
                onChange={handleChange}
                className={`p-2 px-4 rounded bg-gray-100 dark:bg-gray-700 ${className ?? ''}`}
            >
                <option value="">Select {label}</option>
                {options.map((option) => (
                    <option key={option.value} value={option.value}>
                        {option.label}
                    </option>
                ))}
            </select>
        </div>
    );
}

export default DropdownSelect;
