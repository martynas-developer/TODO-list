import React from 'react';
import {Link} from "react-router-dom";

const TodoList = ({ todos }) => {
    return (
        <>
            {todos.map((todo) => (
                <Link to={`/todos/${todo.id}`}
                      className={"col-md-3 alert rounded m-3 " + (todo.completedAt ? 'alert-success' : 'alert-warning')}
                      key={todo.id}>
                    <p>{todo.title}</p>
                    <p>{todo.description}</p>
                </Link>
            ))}
        </>
    );
}

export default TodoList
