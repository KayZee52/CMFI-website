'use server';

/**
 * @fileOverview Summarizes lengthy timeline milestones using generative AI.
 *
 * - summarizeMilestone - A function that summarizes a given milestone text.
 * - SummarizeMilestoneInput - The input type for the summarizeMilestone function.
 * - SummarizeMilestoneOutput - The return type for the summarizeMilestone function.
 */

import {ai} from '@/ai/genkit';
import {z} from 'genkit';

const SummarizeMilestoneInputSchema = z.object({
  milestoneText: z.string().describe('The lengthy text of a timeline milestone to be summarized.'),
});
export type SummarizeMilestoneInput = z.infer<typeof SummarizeMilestoneInputSchema>;

const SummarizeMilestoneOutputSchema = z.object({
  summary: z.string().describe('A concise summary of the milestone text.'),
});
export type SummarizeMilestoneOutput = z.infer<typeof SummarizeMilestoneOutputSchema>;

export async function summarizeMilestone(input: SummarizeMilestoneInput): Promise<SummarizeMilestoneOutput> {
  return summarizeMilestoneFlow(input);
}

const summarizeMilestonePrompt = ai.definePrompt({
  name: 'summarizeMilestonePrompt',
  input: {schema: SummarizeMilestoneInputSchema},
  output: {schema: SummarizeMilestoneOutputSchema},
  prompt: `Summarize the following milestone text into a concise summary:

  Milestone Text: {{{milestoneText}}}
  Summary:`,
});

const summarizeMilestoneFlow = ai.defineFlow(
  {
    name: 'summarizeMilestoneFlow',
    inputSchema: SummarizeMilestoneInputSchema,
    outputSchema: SummarizeMilestoneOutputSchema,
  },
  async input => {
    const {output} = await summarizeMilestonePrompt(input);
    return output!;
  }
);
