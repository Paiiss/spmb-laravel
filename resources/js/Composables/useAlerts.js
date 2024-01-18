import { ref } from "vue";
import { v4 as uuidv4 } from "uuid";
const alerts = ref([]);

export default function useAlerts() {
    const removeAlertTimeout = (id) => {
        setTimeout(() => {
            alerts.value = alerts.value.filter((alert) => alert.id !== id);
        }, 3000);
    };

    const addAlert = (alert) => {
        const id = uuidv4();
        alerts.value.push({
            id: id,
            ...alert,
        });
        removeAlertTimeout(id);
        if (alerts.value.length > 5) {
            alerts.value = alerts.value.slice(1);
        }
    };

    const removeAlert = (id) => {
        alerts.value = alerts.value.filter((alert) => alert.id !== id);
    };

    return {
        alerts,
        addAlert,
        removeAlert,
    };
}
