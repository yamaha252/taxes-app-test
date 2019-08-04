import {NgModule} from '@angular/core';
import {ApolloModule, Apollo} from 'apollo-angular';
import {HttpLinkModule, HttpLink} from 'apollo-angular-link-http';
import {onError} from 'apollo-link-error';
import {InMemoryCache} from 'apollo-cache-inmemory';
import {environment} from '../../environments/environment';
import {ApolloLink} from 'apollo-link';
import {MatSnackBarModule, MatSnackBar} from '@angular/material';

@NgModule({
  imports: [
    MatSnackBarModule,
  ],
  exports: [ApolloModule, HttpLinkModule],
})
export class GraphQLModule {
  constructor(private apollo: Apollo,
              private httpLink: HttpLink,
              private snackBar: MatSnackBar) {
    const http = this.httpLink.create({
      uri: environment.apiUrl
    });

    const error = onError(({graphQLErrors, networkError}) => {
      if (graphQLErrors) {
        const errors = graphQLErrors.map(
          ({message, locations, path}) => `Message: ${message}, Location: ${locations}, Path: ${path}`
        );
        this.snackBar.open(`[GraphQL errors]: ${errors.join(' ')}`, null, {
          duration: 3000,
        });
      }
      if (networkError) {
        this.snackBar.open(`[Network error]: ${networkError.message}`, null, {
          duration: 3000,
        });
      }
    });

    apollo.create({
      link: ApolloLink.from([error, http]),
      cache: new InMemoryCache(),
      defaultOptions: {
        query: {
          fetchPolicy: 'network-only'
        }
      }
    });
  }
}
