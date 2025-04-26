import Select from 'react-select';
import chroma from 'chroma-js';

interface ColourOption {
    label: string;
    value: string;
    color: string;
}

interface MultiSelectProps {
    options: ColourOption[];
    value: ColourOption[];
    onChange: (selectedOptions: ColourOption[]) => void;
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
        backgroundColor: 'var(--bg-color)',
    }),
    option: (styles: any, { data, isDisabled, isFocused, isSelected }: any) => {
        const color = chroma(data.color);
        return {
            ...styles,
            backgroundColor: isDisabled ? undefined : isSelected ? data.color : isFocused ? color.alpha(0.1).css() : undefined,
            color: isDisabled ? '#ccc' : isSelected ? (chroma.contrast(color, 'white') > 2 ? 'white' : 'black') : data.color,
            cursor: isDisabled ? 'not-allowed' : 'pointer',
            ':active': {
                ...styles[':active'],
                backgroundColor: !isDisabled ? (isSelected ? data.color : color.alpha(0.3).css()) : undefined,
            },
        };
    },
    multiValue: (styles: any, { data }: any) => {
        const color = chroma(data.color);
        return {
            ...styles,
            backgroundColor: color.alpha(0.1).css(),
        };
    },
    multiValueLabel: (styles: any, { data }: any) => ({
        ...styles,
        color: data.color,
    }),
    multiValueRemove: (styles: any, { data }: any) => ({
        ...styles,
        color: data.color,
        ':hover': {
            backgroundColor: data.color,
            color: 'white',
        },
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
