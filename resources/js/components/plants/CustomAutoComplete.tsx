import React, { useEffect, useRef, useState } from 'react';
import { FixedSizeList as List } from 'react-window';
import { Input } from '../ui/input';

interface CustomAutocompleteProps<T = string> {
    label?: string;
    options: T[];
    value: T;
    onChange: (value: T) => void;
    loading?: boolean;
    className?: string;
    disabled?: boolean;
}

const ITEM_HEIGHT = 40;
const MAX_VISIBLE_ITEMS = 6;

const CustomAutocomplete: React.FC<CustomAutocompleteProps> = ({ label, options, value, onChange, loading = false, className = '', ...props }) => {
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
        if (props?.disabled) return;
        const val = e.target.value;
        setInputValue(val);
        const filtered = options.filter((option) => option.toLowerCase().includes(val.toLowerCase()));
        setFilteredOptions(filtered);
        setIsOpen(true);
    };

    const handleOptionClick = (option: string) => {
        if (props?.disabled) return;
        setIsOpen(false);
        setInputValue(option);
        onChange(option);
    };

    const handleFocus = () => {
        if (props?.disabled) return;
        const filtered = options.filter((option) => option.toLowerCase().includes(inputValue.toLowerCase()));
        setFilteredOptions(filtered);
        setIsOpen(true);
    };

    const renderRow = ({ index, style }: { index: number; style: React.CSSProperties }) => (
        <li
            style={style}
            key={filteredOptions[index]}
            onClick={() => handleOptionClick(filteredOptions[index])}
            className="cursor-pointer truncate px-4 py-2 text-sm hover:bg-gray-200 dark:hover:bg-gray-600"
        >
            {filteredOptions[index]}
        </li>
    );

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
                {...props}
            />
            <div>
                {isOpen && (
                    <div className="absolute z-10 mt-1 w-full max-w-md overflow-hidden rounded border border-gray-300 bg-white shadow dark:border-gray-600 dark:bg-gray-800">
                        {loading ? (
                            <div className="px-4 py-2 text-sm text-gray-500 italic dark:text-gray-400">Loading...</div>
                        ) : filteredOptions.length > 0 ? (
                            <List
                                height={Math.min(filteredOptions.length, MAX_VISIBLE_ITEMS) * ITEM_HEIGHT}
                                itemCount={filteredOptions.length}
                                itemSize={ITEM_HEIGHT}
                                width="100%"
                            >
                                {renderRow}
                            </List>
                        ) : (
                            <div className="px-4 py-2 text-sm text-gray-500 italic dark:text-gray-400">No options found</div>
                        )}
                    </div>
                )}
            </div>
        </div>
    );
};

export default CustomAutocomplete;
