declare namespace App.Dtos {
export type AuthorDto = {
id: number;
name: string;
created_at: string;
updated_at: string;
};
export type BookDto = {
id: number;
title: string;
description: string;
year: string;
catalog: string;
active: boolean;
category: App.Dtos.CategoryDto | null;
editorial: App.Dtos.EditorialDto | null;
authors: Array<App.Dtos.AuthorDto> | null;
city: App.Dtos.CityDto | null;
embedding: App.Dtos.BookEmbeddingDto | null;
sentiment: App.Dtos.BookSentimentDto | null;
has_embeddings: boolean | null;
has_sentiment: boolean | null;
};
export type BookEmbeddingDto = {
id: number;
book_id: string;
embeddings_model: string;
embeddings: Array<any>;
created_at: string;
updated_at: string;
};
export type BookFilterDto = {
search: string | null;
dates: Array<any> | null;
year: string | null;
categories: Array<any> | null;
status: Array<any> | null;
};
export type BookSentimentDto = {
id: number;
book_id: string;
sentiment_model: string;
positive_sentiment: string;
negative_sentiment: string;
neutral_sentiment: string;
created_at: string;
updated_at: string;
};
export type CategoryDto = {
id: number;
name: string;
created_at: string;
updated_at: string;
};
export type CityDto = {
id: number;
name: string;
created_at: string;
updated_at: string;
};
export type EditorialDto = {
id: number;
name: string;
created_at: string;
updated_at: string;
};
}
