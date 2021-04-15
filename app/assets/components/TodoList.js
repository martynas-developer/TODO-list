import React from 'react';
import {Link} from "react-router-dom";

const TodoList = ({ todos }) => {
    return (
        <>
            {todos.map((todo) => (
                <div key={todo.id}>
                    <Link to={`/todos/${todo.id}`}>
                        <p>{todo.title}</p>
                        <p>{todo.description}</p>
                    </Link>
                </div>
            ))}
        </>
    );
}

export default TodoList
