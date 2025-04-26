import Select from 'react-select';

interface MultiOption {
    label: string;
    value: string;
}

interface MultiSelectProps {
    options: MultiOption[];
    value: MultiOption[];
    onChange: (selectedOptions: MultiOption[]) => void;
}

const colourStyles = {
    control: (styles: any) => ({
        ...styles,
        backgroundColor: 'transparent',
        borderColor: '#E5E7EB',
        borderWidth: '1px',
        borderRadius: '0.375rem',
        padding: '0.25rem',
        boxShadow: 'none',
        minHeight: '2.5rem',
    }),
    menu: (styles: any) => ({
        ...styles,
        borderRadius: '0.375rem',
        boxShadow: '0 2px 10px rgba(0, 0, 0, 0.1)',
        borderColor: '#E5E7EB',
        backgroundColor: 'purple',
    }),
    option: (styles: any, { isDisabled, isSelected }: any) => {
        return {
            ...styles,
            backgroundColor: isDisabled ? undefined : isSelected ? 'none' : undefined,
            color: '#ccc',
            cursor: isDisabled ? 'not-allowed' : 'pointer',
            ':active': {
                ...styles[':active'],
                backgroundColor: !isDisabled ? 'none' : undefined,
            },
        };
    },
    multiValue: (styles: any, { data }: any) => {
        return {
            ...styles,
        };
    },
    multiValueLabel: (styles: any, { data }: any) => ({
        ...styles,
        backgroundColor: 'yellow',
    }),
    multiValueRemove: (styles: any, { data }: any) => ({
        ...styles,
        backgroundColor: 'pink',
    }),
};

const MultiSelect = ({ options, value, onChange }: MultiSelectProps) => {
    return (
        <div className="mt-4 w-full">
            <Select
                options={options}
                isMulti
                value={value}
                onChange={onChange}
                styles={colourStyles}
                placeholder="Select colors"
                className="w-full"
            />
        </div>
    );
};

export default MultiSelect;
