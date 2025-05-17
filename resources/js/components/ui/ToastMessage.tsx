import { AnimatePresence, motion } from 'framer-motion';

type ToastType = 'success' | 'warning' | 'error' | 'info';

const typeStyles: Record<ToastType, string> = {
  success:
    'bg-gradient-to-r from-green-400 to-green-600 text-white ring-green-700/30 shadow-lg',
  warning:
    'bg-gradient-to-r from-yellow-400 to-yellow-600 text-gray-900 ring-yellow-700/30 shadow-md',
  error:
    'bg-gradient-to-r from-red-500 to-red-700 text-white ring-red-800/40 shadow-lg',
  info:
    'bg-gradient-to-r from-blue-400 to-blue-600 text-white ring-blue-700/30 shadow-md',
};

interface ToastMessageProps {
  message: string;
  type?: ToastType;
}

export default function ToastMessage({
  message,
  type = 'success',
}: ToastMessageProps) {
  return (
    <AnimatePresence>
      {message && (
        <motion.div
          initial={{ opacity: 0, y: -20 }}
          animate={{ opacity: 1, y: 0 }}
          exit={{ opacity: 0, y: -20 }}
          transition={{ duration: 0.3 }}
          className={`fixed top-4 left-1/2 z-50 -translate-x-1/2 max-w-md rounded-lg px-6 py-3 font-medium select-none cursor-default ring-1 ${typeStyles[type]}`}
          role="alert"
          aria-live="assertive"
        >
          {message}
        </motion.div>
      )}
    </AnimatePresence>
  );
}
