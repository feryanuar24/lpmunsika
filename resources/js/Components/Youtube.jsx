import React, { useEffect, useState } from "react";

export default function Youtube() {
    const apiKey = "AIzaSyD96qm7VkcGgqTtgPnjgxdNAfE0ACJqCQg";
    const channelId = "UCvIwacqd0o6e4zEhU9ytkNg";
    const maxResults = 3;

    const [videos, setVideos] = useState([]);
    const [error, setError] = useState(null);

    useEffect(() => {
        const apiUrl = `https://www.googleapis.com/youtube/v3/search?key=${apiKey}&channelId=${channelId}&part=snippet,id&order=date&maxResults=${maxResults}`;

        fetch(apiUrl)
            .then((response) => {
                if (response.status === 403) {
                    setError("API error 403: Akses ditolak");
                    return null;
                }
                return response.json();
            })
            .then((data) => {
                setVideos(data.items);
            })
            .catch((error) => "Terjadi kesalahan dalam melakukan permintaan");
    }, []);

    return (
        <div>
            {error ? (
                <div className="p-5">
                    <h2 className="font-bold text-3xl border-b-8 w-max border-red-500 uppercase">
                        <a href="https://www.youtube.com/@LPMUNSIKA">
                            LPM Channel
                        </a>
                    </h2>
                    <hr />
                    <div className="mt-10">{error}</div>
                </div>
            ) : (
                <div className="p-5">
                    <h2 className="font-bold text-3xl border-b-8 w-max border-red-500 uppercase">
                        <a href="https://www.youtube.com/@LPMUNSIKA">
                            LPM Channel
                        </a>
                    </h2>
                    <hr />
                    <div>
                        {videos.map((video) => (
                            <iframe
                                key={video.id.videoId}
                                src={`https://www.youtube.com/embed/${video.id.videoId}`}
                                title={video.snippet.title}
                                allowFullScreen
                                style={{ borderRadius: "12px" }}
                                width="100%"
                                height="352"
                                loading="lazy"
                                className="mt-10 h-60"
                            />
                        ))}
                    </div>
                </div>
            )}
        </div>
    );
}
