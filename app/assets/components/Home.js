import React from 'react';
import TodoList from "./TodoList";
import useFetch from "../utils/useFetch";

const Home = () => {
    const { data: todos, isLoading, error } = useFetch('/api/tasks')

console.log(process.env, '1')


    return (
        <>
            {error && <div>{ error }</div>}
            {isLoading && <div>Loading...</div>}
            {todos && <TodoList todos={todos} />}
        </>
    )
}

export default Home;
