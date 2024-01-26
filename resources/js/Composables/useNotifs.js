import { ref } from "vue";
const notification = ref([]);

export default function useNotif() {
    const addNotif = (notif) => {
        notification.value.push({
            ...notif,
        });
        if (notification.value.length > 5) {
            notification.value = notification.value.slice(1);
        }
    };

    const removeNotif = (id) => {
        notification.value = notification.value.filter(
            (notif) => notif.id !== id
        );
    };

    const unreadNotif = () => {
        return notification.value.filter((notif) => !notif.read_at).length;
    };

    return {
        notification,
        addNotif,
        removeNotif,
        unreadNotif,
    };
}
