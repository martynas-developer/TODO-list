import React, { useState } from 'react';
import { useHistory } from "react-router-dom";
import useFetch from "../utils/useFetch";

const TodoCreate = () => {
    const [description, setDescription] = useState('')
    const [completedAt, setCompletedAt] = useState('')
    const history = useHistory();
    const todo = { description, completedAt };
    const { executeFetch, isLoading } = useFetch(
        'http://localhost:8080/api/tasks',
        { method: 'POST', body: JSON.stringify(todo)},
        {immediate: false}
    );

     const handleSubmit = (e) => {
         e.preventDefault();
         executeFetch().then(() => {
             history.push('/');
         });
     }

    return (
        <div>
            <h2>create new todo</h2>
            { description }
            { completedAt }
            <form onSubmit={handleSubmit}>
                <label htmlFor="description">description:</label>
                <textarea
                    id="description"
                    value={description}
                    onChange={(e) => setDescription(e.target.value)}
                ></textarea>
                <label htmlFor="completedAt">completed at:</label>
                <input
                    type="date"
                    id="completedAt"
                    value={completedAt}
                    onChange={(e) => setCompletedAt(e.target.value)}
                />
                {!isLoading && <button type="submit">Create</button>}
                {isLoading && <button type="submit" disabled>Creating...</button>}
            </form>
        </div>
    );
}

export default TodoCreate
