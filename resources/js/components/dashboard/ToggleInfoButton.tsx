type ToggleInfoButtonProps = {
    isVisible: boolean;
    onToggle: () => void;
};

function ToggleInfoButton({ isVisible, onToggle }: ToggleInfoButtonProps) {
    return (
        <div className="flex justify-end">
            <button
                className="rounded-lg bg-blue-100 px-4 py-2 text-blue-500 transition duration-300 ease-in-out hover:bg-blue-500 hover:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-blue-950 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white dark:focus:ring-blue-400"
                onClick={onToggle}
            >
                {isVisible ? 'Hide' : 'Show'} User Information
            </button>
        </div>
    );
}

export default ToggleInfoButton;
