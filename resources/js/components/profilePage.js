export default function profilePage() {
    return {
        tab: "profile",
        profileView: "info",
        settingsView: "cards",

        init() {
            const hash = window.location.hash.replace("#", "");
            if (["profile", "settings", "privacy"].includes(hash)) {
                this.tab = hash;
            }
        },

        async blockUser(userId) {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    console.error('CSRF token not found');
                    alert('Security error: CSRF token missing');
                    return;
                }

                const response = await fetch(`/profile/${userId}/block`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                });

                const data = await response.json();

                if (response.ok) {
                    window.location.reload();
                } else {
                    console.error('Block failed:', data);
                    alert(`Failed to block user: ${data.message || 'Unknown error'}`);
                }
            } catch (error) {
                console.error('Error blocking user:', error);
                alert(`Error blocking user: ${error.message}`);
            }
        },

        async unblockUser(userId) {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    console.error('CSRF token not found');
                    alert('Security error: CSRF token missing');
                    return;
                }

                const response = await fetch(`/profile/${userId}/unblock`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                });

                const data = await response.json();

                if (response.ok) {
                    window.location.reload();
                } else {
                    console.error('Unblock failed:', data);
                    alert(`Failed to unblock user: ${data.message || 'Unknown error'}`);
                }
            } catch (error) {
                console.error('Error unblocking user:', error);
                alert(`Error unblocking user: ${error.message}`);
            }
        },
    };
}
