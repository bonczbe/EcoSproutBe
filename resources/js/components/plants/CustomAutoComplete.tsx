import React, { useEffect, useRef, useState } from 'react';
import { Input } from '../ui/input';

interface CustomAutocompleteProps {
    label?: string;
    options: string[];
    value: string;
    onChange: (value: string) => void;
    loading?: boolean;
    className?: string;
}

const CustomAutocomplete: React.FC<CustomAutocompleteProps> = ({ label, options, value, onChange, loading = false, className = '' }) => {
    const [inputValue, setInputValue] = useState(value);
    const [isOpen, setIsOpen] = useState(false);
    const [filteredOptions, setFilteredOptions] = useState<string[]>([]);
    const wrapperRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        setInputValue(value);
    }, [value]);

    useEffect(() => {
        const handleClickOutside = (event: MouseEvent) => {
            if (wrapperRef.current && !wrapperRef.current.contains(event.target as Node)) {
                setIsOpen(false);
            }
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, []);

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const val = e.target.value;
        setInputValue(val);
        const filtered = options.filter((option) => option.toLowerCase().includes(val.toLowerCase()));
        setFilteredOptions(filtered);
        setIsOpen(true);
    };

    const handleOptionClick = (option: string) => {
        setIsOpen(false);
        setInputValue(option);
        onChange(option);
    };

    const handleFocus = () => {
        const filtered = options.filter((option) => option.toLowerCase().includes(inputValue.toLowerCase()));
        setFilteredOptions(filtered);
        setIsOpen(true);
    };

    return (
        <div ref={wrapperRef} className={`relative flex flex-col ${className}`}>
            <Input
                className="w-full max-w-md rounded bg-gray-100 p-2 px-4 dark:bg-gray-700"
                type="text"
                name="family_name"
                onChange={handleInputChange}
                label={label}
                value={inputValue}
                placeholder={`Select ${label}`}
                onFocus={handleFocus}
            />
            <div>
                {isOpen && (
                    <ul className="absolute z-10 mt-1 max-h-60 w-full max-w-md overflow-auto rounded border border-gray-300 bg-white shadow dark:border-gray-600 dark:bg-gray-800">
                        {loading ? (
                            <li className="px-4 py-2 text-sm text-gray-500 italic dark:text-gray-400">Loading...</li>
                        ) : filteredOptions.length > 0 ? (
                            filteredOptions.map((option) => (
                                <li
                                    key={option}
                                    onClick={() => handleOptionClick(option)}
                                    className="cursor-pointer px-4 py-2 text-sm hover:bg-gray-200 dark:hover:bg-gray-600"
                                >
                                    {option}
                                </li>
                            ))
                        ) : (
                            <li className="px-4 py-2 text-sm text-gray-500 italic dark:text-gray-400">No options found</li>
                        )}
                    </ul>
                )}
            </div>
        </div>
    );
};

export default CustomAutocomplete;
