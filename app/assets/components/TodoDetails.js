import React from 'react';
import { useParams } from "react-router-dom";
import useFetch from "../utils/useFetch";

const TodoDetails = () => {
    const { id } = useParams();
    const { data: todo, error, isLoading } = useFetch('/api/tasks/' + id);

    return (
        <div>
            {error && <div>{ error }</div>}
            {isLoading && <div>Loading...</div>}
            {todo && todo.id}
        </div>
    );
}

export default TodoDetails
