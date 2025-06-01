import React, { useState, useRef, useEffect } from 'react';

interface CustomAutocompleteProps {
  label?: string;
  options: string[];
  value: string;
  onChange: (value: string) => void;
  loading?: boolean;
  className?: string;
}

const CustomAutocomplete: React.FC<CustomAutocompleteProps> = ({
  label,
  options,
  value,
  onChange,
  loading = false,
  className = '',
}) => {
  const [inputValue, setInputValue] = useState(value);
  const [isOpen, setIsOpen] = useState(false);
  const [filteredOptions, setFilteredOptions] = useState<string[]>([]);
  const wrapperRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    setInputValue(value);
  }, [value]);

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const val = e.target.value;
    setInputValue(val);
    const filtered = options.filter((option) =>
      option.toLowerCase().includes(val.toLowerCase())
    );
    setFilteredOptions(filtered);
    setIsOpen(true);
  };

  const handleOptionClick = (option: string) => {
    setInputValue(option);
    onChange(option);
    setIsOpen(false);
  };

  const handleFocus = () => {
  const filtered = options.filter((option) =>
    option.toLowerCase().includes(inputValue.toLowerCase())
  );
  setFilteredOptions(filtered);
  setIsOpen(true);
};

  return (
    <div className={`flex flex-col relative ${className}`} ref={wrapperRef}>
      {label && (
        <label className="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
          {label}
        </label>
      )}
      <input
        type="text"
        value={inputValue}
        onFocus={handleFocus}
        onChange={handleInputChange}
        className="p-2 px-4 rounded bg-gray-100 dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100 focus:outline-none"
        placeholder={`Select ${label}`}
      />
      <div>

      {isOpen && (
        <ul className="absolute z-10 mt-1 max-h-60 overflow-auto w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded shadow">
          {loading ? (
            <li className="px-4 py-2 text-sm text-gray-500 dark:text-gray-400 italic">
              Loading...
            </li>
          ) : filteredOptions.length > 0 ? (
            filteredOptions.map((option) => (
              <li
                key={option}
                onClick={() => handleOptionClick(option)}
                className="px-4 py-2 text-sm cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600"
              >
                {option}
              </li>
            ))
          ) : (
            <li className="px-4 py-2 text-sm text-gray-500 dark:text-gray-400 italic">
              No options found
            </li>
          )}
        </ul>
      )}
      </div>

    </div>
  );
};

export default CustomAutocomplete;
