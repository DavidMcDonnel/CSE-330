transpose_64mod(int M, int N, int A[N][M], int B[M][N])
{
int ii, jj, i, j;
int a1, a2, a3, a4, a5, a6, a7, a8;
we borrow (1, 57) -- (4, 64) as a higher level cache
// // diagonal
 for(ii = 0; ii < N; ii += 8) {
  for(jj = 0; jj < M; jj += 8) {
   if (ii == jj && ii != 56) {
    // up 4 lines, = 8
     for (i = ii; i < ii + 4; ++i) {
      a1 = A[i][jj];
       a2 = A[i][jj+1];
        a3 = A[i][jj+2];
         a4 = A[i][jj+3];
          a5 = A[i][jj+4];
           a6 = A[i][jj+5];
            a7 = A[i][jj+6];
             a8 = A[i][jj+7];
              B[i][jj] = a1;
               B[i][jj+1] = a2;
                B[i][jj+2] = a3;
                 B[i][jj+3] = a4;
                  B[i][jj+4] = a5;
                   B[i][jj+5] = a6;
                    B[i][jj+6] = a7;
                     B[i][jj+7] = a8;
                      // save to cache, first time = 4 miss, else = 0 miss.
                       B[i - ii][56] = a5;
                        B[i - ii][57] = a6;
                         B[i - ii][58] = a7;
                          B[i - ii][59] = a8;
                           }

