function addAvailability() {
            const list = document.querySelector('.availability-list');
            const li = document.createElement('li');
            li.innerHTML = '<input type="text" name="availability[]" placeholder="Enter availability" required /> <br>';
            list.appendChild(li);
        }

        function markForDeletion(button, id) {
            const input = document.getElementById('delete_availability');
            let current = input.value ? input.value.split(',') : [];
            if (!current.includes(id.toString())) {
                current.push(id);
                input.value = current.join(',');
            }
            button.parentElement.remove();
        }