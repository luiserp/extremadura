export namespace App.Dtos {
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
        category: App.Dtos.CategoryDto;
        editorial: App.Dtos.EditorialDto;
        authors: Array<App.Dtos.AuthorDto>;
        city: App.Dtos.CityDto;
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
