import { ref } from "vue";
import axios from "axios";
const notification = ref([]);

export default function useNotif() {
    const addNotif = (notif) => {
        notification.value.push(notif);

        notification.value = notification.value.sort((a, b) => {
            return new Date(b.created_at) - new Date(a.created_at);
        });
    };

    const removeNotif = async (id) => {
        await axios.patch(route("notifications.destroy", id));
    };

    const readNotif = async (id) => {
        await axios.patch(route("notifications.read", id));
        notification.value = notification.value.map((notif) => {
            if (notif.id === id) {
                notif.read_at = new Date().toISOString();
            }
            return notif;
        });
    };

    const unreadNotif = () => {
        return notification.value.filter((notif) => !notif.read_at).length;
    };

    return {
        notification,
        addNotif,
        removeNotif,
        unreadNotif,
        readNotif,
    };
}
