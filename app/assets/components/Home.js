import React from 'react';
import TodoList from "./TodoList";
import useFetch from "../utils/useFetch";
import {Link} from "react-router-dom";

const Home = () => {
    const { data: todos, isLoading, error } = useFetch('/api/tasks')

    return (
        <div className="container">
            <div className="row justify-content-center">
                {error && <div>{error}</div>}
                {isLoading &&
                    <div className="spinner-border text-primary" role="status">
                        <span className="sr-only">Loading...</span>
                    </div>
                }
                {todos && <TodoList todos={todos}/>}
                {todos && todos.length === 0 &&
                    <>
                        <h2 className="col-12 text-center">It seems to be empty here...</h2>
                        <h4 className="col-12 text-center">Start by adding you first todo:</h4>
                        <Link to="/todos" className="nav-item nav-link">
                            <button className="btn btn-primary btn-block">Create todo</button>
                        </Link>
                    </>
                }
            </div>
        </div>
    )
}

export default Home;
